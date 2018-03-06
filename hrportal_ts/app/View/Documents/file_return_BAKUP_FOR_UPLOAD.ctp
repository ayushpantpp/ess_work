<span class="uk-text-upper uk-text-small"><h3>Want To Send Any Other Files Manually !</h3></span>

<?php echo $this->Form->create('docs', array('url' => array('controller' => 'documents', 'action' => 'request_complete'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
<div class="md-card">
    <div class="md-card-content large-padding">
        <div class="uk-grid" id='TextBoxesGroup' data-uk-grid-margin>
            <div class="uk-width-medium-1-1" >
                <div class="parsley-row">
                    <label for="cc_num">Manual Files: </label>
                    
                        <?php 
                        echo $this->form->input('docs.upl_doc.', array('type'=>'text','label'=>false,'class'=>"md-input")); 
                        //echo $this->Form->input('docs.upl_doc.', array('type' => 'text', 'label' => false, 'id' => 'file_upload-select'));
                        echo $this->Form->input('parent_id', array('type' => 'hidden','value'=>$parent_id, 'label' => false));
                        echo $this->Form->input('reqID', array('type' => 'hidden','value'=>$reqID, 'label' => false));
                        ?>
                    
                </div>
            </div>                   
        </div>
        <div class="uk-grid">
            <div class="uk-width-1-1">                        
                <input type='button' class="md-btn md-btn-primary"  value='Add More' id='addButton'>
                <input type='button' class="md-btn md-btn-danger" value='Remove' id='removeButton'>         
                <input type='submit' class="md-btn md-btn-success" onclick="return confirm('Are you sure?');"   value='Click To Return' id='addButton'>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>
 <script src="<?php echo $this->webroot;?>js/jquery.min.js"></script>
<script src="<?php echo $this->webroot;?>js/jquery-ui.min.js"></script>
<script type="text/javascript">
 
$(document).ready(function(){
 
    var counter = 2;
 
    $("#addButton").click(function () {
 
    if(counter>10){
            alert("Only 10 textboxes allow");
            return false;
    }
 
    var newTextBoxDiv = $(document.createElement('div'))
         .attr({id:'TextBoxDiv' + counter,class:"uk-width-medium-1-1 margin-bottom"});
 
    newTextBoxDiv.after().html('<br><div class="parsley-row">'+
                            '<label for="upl_doc">Manual Files: <span class="req"><sup>*</sup>&nbsp;</span></label>'+
                                '<?php echo $this->form->input('docs.upl_doc.', array('type'=>'text','label'=>false,'required'=>true,'class'=>"md-input")); ?>'+
                        '</div>');
 
    newTextBoxDiv.appendTo("#TextBoxesGroup");
 
 
    counter++;
     });
 
     $("#removeButton").click(function () {
    if(counter==1){
          alert("No more textbox to remove");
          return false;
       }
    counter--;
        $("#TextBoxDiv" + counter).remove();
     });    
  });
</script>
