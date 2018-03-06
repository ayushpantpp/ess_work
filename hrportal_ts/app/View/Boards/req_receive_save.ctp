<script>
    function fieldsDisable(val) {
        if (val != '') {
            //var val=jQuery("#type").val();
            $.ajax({
                type: "POST",
                url: '<?php echo $this->webroot ?>Boards/fields/' + val,
                //data:'project_id='+val,
                success: function (data) {
                    //alert(data);
                    $("#newfield").html(data);
                }
            });
        }
    }

</script>

<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">

        <h1>Request Receiving</h1>

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
                <?php echo $this->Form->create('doc', array('url' => array('controller' => 'Boards', 'action' => 'req_receive_save'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                ?>
                <h3 class="heading_a">Request Receiving</h3>
                <div class="uk-grid" data-uk-grid-margin>
				
					 <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="act_off">Request Serial #</label>
                            <?php echo $this->form->input('req_ref_serial_no', array('type' => 'text', 'label' => false, 'required' => true, 'value' => $lastSerialId, 'class' => "md-input", 'readonly'=>'readonly'));
							?>

                        </div>

                    </div>
					
					 <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="act_off">Request Category<span class="req">*</span></label>
                            <select name="signatory" required="required" class="md-input data-md-selectize label-fixed">
                                <option value="">-- Select --</option>
                                <option value="1">MDA</option>
                                <option value="2">Individual</option>
                                <option value="3">Current Employee</option>
                                <option value="4">Ex-Employee</option>
                                <option value="5">Other Citizen</option>
                                <option value="6">Other Organisation</option>
                                <option value="7">Country Govt</option>
                            </select>

                        </div>

                    </div>
				</div>
				<div class="uk-grid" data-uk-grid-margin=""></div>
				<div class="uk-grid" data-uk-grid-margin > 
					
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="req_cat">Nature of Request <span class="req">*</span></label>
                            <select name="req_cat" required="required" class="md-input data-md-selectize label-fixed">
                                <option value=" ">-- Select --</option>
                                <?php
                                foreach ($RequestType as $key => $rt) {
                                    $value = $key;
                                    $option = $rt;

                                    echo "<option value='" . $value . "'>" . $option . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                    </div>

                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="department">MDA <span class="req">*</span></label>
                            <select name="ministry" required="required" class="md-input data-md-selectize label-fixed">
                                <option value=" ">-- Select --</option>
                                <?php
                                foreach ($Ministry as $key => $rt) {
                                    $value = $key;
                                    $option = $rt;

                                    echo "<option value='" . $value . "'>" . $option . "</option>";
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                </div>

				<div class="uk-grid" data-uk-grid-margin=""></div>
                <div class="uk-grid" data-uk-grid-margin > 

                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Reference Number <span class="req fixed">*</span></label>
                            <?php
                            echo $this->form->input('refnum', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="subject">Subject <span class="req">*</span></label>
                            <?php echo $this->form->textarea('subject', array('label' => false, 'required' => true, 'class' => "md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dor">Date of Request <span class="req">*</span></label>
                            <?php
                            echo $this->form->input('doreq', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value' => $dos, 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dorc">Date of Received <span class="req">*</span></label>
                            <?php
                            echo $this->form->input('dorec', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value' => $dos, 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="act_off">Signatory<span class="req">*</span></label>
                            <?php /*  <select name="signatory" required="required" class="md-input data-md-selectize label-fixed">
                              <option value=" ">-- Select --</option>
                              <?php
                              foreach($Dept_Signatory as $key=>$values){
                              $value = $key;
                              $option = $values;

                              echo "<option value='".$value."'>".$option."</option>";
                              }

                              ?>
                              </select> */ ?>
                            <?php
                            echo $this->form->input('signatory', array('type' => "text", 'label' => false, 'required' => true, 'class' => "md-input"));
                            ?>
                        </div>

                    </div>

                   


                </div> 
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="department">Department <span class="req">*</span></label>
                            <select name="department" required="required" onchange="fieldsDisable(this.value);" class="md-input data-md-selectize label-fixed">
                                <option value=" ">-- Select --</option>
                                <?php
                                foreach ($department as $key => $rt) {
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
                    <div id="newfield" class="uk-width-medium-1-2">

                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="department">Attachment <span class="req">*</span></label>
                            <a  class=" md-btn md-btn-primary"> 

                                <?php echo $this->Form->input('upl_doc', array('type' => 'file', 'label' => false, 'id' => 'file_upload-select')); ?>
                            </a>
                        </div>
                    </div>
                </div>

                <div id="newfieldss"  class="uk-grid" data-uk-grid-margin>

                </div>

                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit" class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/Boards/req_receive') ?>">Cancel</a>                       
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
