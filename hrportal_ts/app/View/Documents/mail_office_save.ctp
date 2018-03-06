<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            <h1>Receive Mails</h1>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card">  
            <div class="md-card-content large-padding">
                 
                <?php echo $this->Form->create('doc', array('url' =>array('controller' => 'Documents', 'action' =>'mail_office_save'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); 
                               ?>
                <h3 class="heading_a">Mail's Details</h3>
                
                <div class="uk-grid" data-uk-grid-margin>
                    
                    <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="case_type" class="md-input label-fixed">Serial No. <span class="req">*</span></label>
                                    <?php
                                    echo $this->form->input('serial_no', array('label'=>false,'type' => "text",'required'=>true,'value'=>$SerialNo,'readonly'=>true,'class' => "md-input")); 
                                    ?>
                             </div>
                       </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="remark" class="md-input label-fixed">Received From <span class="req">*</span></label>
                            <?php
                                  echo $this->form->input('rec_from', array('label'=>false,'type' => "text",'required'=>true,'class' => "md-input")); 
                            ?>
                        </div>
                    </div>
                    
                </div> 
                
                <div class="uk-grid" data-uk-grid-margin>
                    
                    <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="case_type" class="md-input label-fixed">Reference</label>
                                    <?php
                                    echo $this->form->input('reference', array('label'=>false,'type' => "text",'class' => "md-input")); 
                                    ?>
                             </div>
                       </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="remark" class="md-input label-fixed">Date of Receiving <span class="req">*</span></label>
                            <?php echo $this->form->input('dor', array('type'=>'text','label' => false,'data-uk-datepicker'=>"{format:'DD-MM-YYYY',maxDate:'".date('d-m-Y')."'}", 'readonly'=>true,'required' => true, 'class' => "md-input label-fixed")); ?>                               
                        </div>
                    </div>
                    
                </div>
                
                
                <div class="uk-grid" data-uk-grid-margin>
                    
                    <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="case_type" class="md-input label-fixed">Subject <span class="req">*</span></label>
                                    <?php
                                    echo $this->form->input('subject', array('label'=>false,'type' => "text",'required'=>true,'class' => "md-input")); 
                                    ?>
                             </div>
                       </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="remark">Remark </label>
                            <?php echo $this->form->textarea('remark', array('label'=>false,'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    
                </div> 
                
            <div class="uk-grid" id='TextBoxesGroup' data-uk-grid-margin>
            <div class="uk-width-medium-1-2" >
                <label for="cc_num"  >Select Mail To Upload* : </label>
                <div class="md-btn md-btn-primary">
                    
                        <?php 
                        echo $this->form->input('upl_doc.', array('type'=>'file','required'=>true,'label'=>false)); 
                        ?>
                </div>
            </div>
            </div>    
        
                <div class="uk-grid" data-uk-grid-margin></div>
            <div class="uk-width-1-1">                        
                <input type='button' class="md-btn md-btn-primary"  value='Add More' id='addButton'>
                <input type='button' class="md-btn md-btn-danger" value='Remove' id='removeButton'>         
            </div>
                
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit" class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('mail_office'); ?>">Cancel</a>                       
                    </div>
                </div>
        
                <?php echo $this->Form->end();?>
            </div>
           </div>
   </div>
</div>
<script src="<?php echo $this->webroot;?>js/jquery.min.js"></script>
<script src="<?php echo $this->webroot;?>js/jquery-ui.min.js"></script>
<script type="text/javascript">
 
$(document).ready(function(){
 
    var counter = 2;
 
    $("#addButton").click(function () {
 
    if(counter>10){
            alert("Only 10 files can upload at a time");
            return false;
    }
 
    var newTextBoxDiv = $(document.createElement('div'))
         .attr({id:'TextBoxDiv' + counter,class:"uk-width-medium-1-1 margin-bottom"});
 
    newTextBoxDiv.after().html('<br><label for="upl_doc">Select File To Upload<span class="req"><sup>*</sup>:&nbsp;</span></label>'+
                            '<div class="md-btn md-btn-primary">'+
                                '<?php echo $this->form->input('upl_doc.', array('type'=>'file','label'=>false,'required'=>true)); ?>'+
                        '</div>');
 
    newTextBoxDiv.appendTo("#TextBoxesGroup");
 
 
    counter++;
     });
 
     $("#removeButton").click(function () {
    if(counter==2){
          alert("No more upload field to remove");
          return false;
       }
    counter--;
        $("#TextBoxDiv" + counter).remove();
     });    
  });
</script>
