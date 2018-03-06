<span class="uk-text-upper uk-text-small"><h3>Send to RMS with marking officer !</h3></span>

<?php echo $this->Form->create('docs', array('url' => array('controller' => 'Documents', 'action' => 'mail_office_action_officer'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked')); 
?>
<input type="hidden" name="mail_office_id" value="<?php echo $MailOfficeID;?>">
<div class="md-card">
    <div class="md-card-content large-padding">
        <div class="uk-grid" id='TextBoxesGroup' data-uk-grid-margin>
            <div class="uk-width-medium-1-2" >
                <div class="parsley-row">
                    <div class="parsley-row">
                                <label for="department">Department <span class="req">*</span></label>
                                <select name="department" required="required" onchange="fieldsDisable(this.value);" class="md-input data-md-selectize label-fixed">
                                    <option value=" ">-- Select --</option>
                                    <?php
                                    foreach($department as $key => $rt){
                                 $value = $key;
                                 $option = $rt;
                                 if($rec['Ministry']['id']==$value){
                                        echo "<option value='".$value."' selected='selected'>".$option."</option>";
                                    }else{
                                        echo "<option value='".$value."'>".$option."</option>";
                                    }
                                }
                                    ?>
                                </select>
                                
                        </div>
                </div>
            </div> 
            
            <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                           <div id="newfield"></div>
                           
                                
                        </div>
                    </div>
        </div>
        <div class="uk-grid">
            <div class="uk-width-1-1">                        
                <input type='submit' class="md-btn md-btn-success" onclick="return confirm('Are you sure?');"   value='Send to RMS' >
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>
 
<script>
    function fieldsDisable(val){
        if(val!=''){
          //  alert(val);
        //var val=jQuery("#type").val();
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Boards/fields/' + val,
            //data:'project_id='+val,
            success: function (data) {
               // alert(data);
                $("#newfield").html(data);
            }
        });
        }
    }
</script>

 