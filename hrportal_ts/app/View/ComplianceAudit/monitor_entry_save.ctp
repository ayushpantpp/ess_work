<script>
    
    function addmorefield(){
        //alert('hiiii');
         $('#clonefield').clone().appendTo('#newclone');
         var c = $('#clone_count').val();
         c++;
        $('#clone_count').val(c);
        if($('#clone_count').val()>='2'){
             $('#remove').show();
         }
    }
    
    function removefield(){
        $("#newclone #clonefield:last").remove();
        var c = $('#clone_count').val();
         c--;
         if(c=='1'){
             $('#remove').hide();
         }
        $('#clone_count').val(c);
    }
    function getTypeForm() {
        
        var audit_param = $('#audit_param').val();

        if (audit_param != ' ') { 
            $.ajax({
                type: "POST",
                url: '<?php echo $this->webroot ?>compliance_audit/audit_form_type/' + audit_param+'/2' ,
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
        <h1>Monitoring and Evaluation Entry</h1>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">  
            <div class="md-card-content large-padding">
                <h3 class="heading_a">Enter Monitoring Details</h3>
                <?php echo $this->Form->create('doc', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'monitor_entry_save'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                ?><br>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            <label for="req_cat">MDA<span class="req">*</span></label>
                            <select name="mda" required="true"  class="md-input data-md-selectize">
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
                            <label for="req_cat">Monitor Parameter<span class="req">*</span></label>
                            <select name="audit_param" id="audit_param" required="true"  onchange="getTypeForm()" class="md-input data-md-selectize">
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


                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row" >
                            <label for="req_cat" >Entry Date<span class="req">*</span></label>
                            <?php 
                            echo $this->form->input('entry_date', array('type' => 'text', 'label' => false,'required'=>true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'class' => "md-input"));
                            ?>

                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                <div  id='TextBoxesGroup'></div>

                <?php echo $this->Form->end(); ?>

            </div>
        </div>
    </div>
