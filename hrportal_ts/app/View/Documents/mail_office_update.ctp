<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            <h1>Modify Mails</h1>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <?php
//        echo "<pre>";
//        print_r($MailOfficeDet);
        ?>
       <div class="md-card">  
            <div class="md-card-content large-padding">
               
                <?php echo $this->Form->create('doc', array('url' =>array('controller' => 'Documents', 'action' =>'mail_office_update'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); 
                echo $this->form->input('reportid', array('type' => "hidden",'value'=>$MailOfficeDet['MailOffice']['id'])); 
                ?>
                <h3 class="heading_a">Mail's Details</h3>
                
                <div class="uk-grid" data-uk-grid-margin>
                    
                    <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="case_type" class="md-input label-fixed">Serial No. <span class="req">*</span></label>
                                    <?php
                                    echo $this->form->input('serial_no', array('label'=>false,'type' => "text",'required'=>true,'value'=>$MailOfficeDet['MailOffice']['serial_no'],'readonly'=>true,'class' => "md-input")); 
                                    ?>
                             </div>
                       </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="remark" class="md-input label-fixed">Received From <span class="req">*</span></label>
                            <?php
                                  echo $this->form->input('rec_from', array('label'=>false,'type' => "text",'value'=>$MailOfficeDet['MailOffice']['receive_from'],'required'=>true,'class' => "md-input")); 
                            ?>
                        </div>
                    </div>
                    
                </div> 
                
                <div class="uk-grid" data-uk-grid-margin>
                    
                    <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="case_type" class="md-input label-fixed">Reference</label>
                                    <?php
                                    echo $this->form->textarea('reference', array('label'=>false,'type' => "text",'value'=>$MailOfficeDet['MailOffice']['reference'],'class' => "md-input")); 
                                    ?>
                             </div>
                       </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="remark" class="md-input label-fixed">Date of Receiving<span class="req">*</span></label>
                            <?php 
                             $rec_date=date("d-m-Y", strtotime($MailOfficeDet['MailOffice']['receiving_date']));
                            echo $this->form->input('dor', array('type'=>'text','label' => false,'data-uk-datepicker'=>"{format:'DD-MM-YYYY',maxDate:'".date('d-m-Y')."'}", 'value'=>$rec_date,'readonly'=>true,'required' => true, 'class' => "md-input label-fixed")); ?>                               
                        </div>
                    </div>
                    
                </div>
                
                
                <div class="uk-grid" data-uk-grid-margin>
                    
                    <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="case_type" class="md-input label-fixed">Subject <span class="req">*</span></label>
                                    <?php
                                    echo $this->form->textarea('subject', array('label'=>false,'type' => "text",'value'=>$MailOfficeDet['MailOffice']['subject'],'required'=>true,'class' => "md-input")); 
                                    ?>
                             </div>
                       </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="remark">Remark </label>
                            <?php echo $this->form->textarea('remark', array('label'=>false,'value'=>$MailOfficeDet['MailOffice']['remark'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    
                </div> 
            <div class="uk-grid"  data-uk-grid-margin>
            
                
                
                <?php 
                foreach($MailOfficeDet['MailOfficeAttachFiles'] as $recc){?>
                    <div class="uk-width-medium-1-2" >
                    <?php
                  echo $recc['attach_file'];?>
                </div>
                <div class="uk-width-medium-1-2" >
                <a class="md-btn md-btn-danger" href="<?php echo $this->Html->url('mail_office_file_remove/'.base64_encode($MailOfficeDet['MailOffice']['id']).'/'.base64_encode($recc['id'])); ?>" onclick="return confirm('Are you sure?');">Remove</a>                       
                </div>
                      <?php
                }
                ?>
                
            </div> 
            <div class="uk-grid" id='TextBoxesGroup' data-uk-grid-margin>
            <div class="uk-width-medium-1-2" >
                <label for="cc_num"  >Select Mail To Upload: </label>
                <div class="md-btn md-btn-primary">
                        <?php 
                        echo $this->form->input('upl_doc.', array('type'=>'file','label'=>false)); 
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
 
    newTextBoxDiv.after().html('<br><label for="upl_doc">Select Mail To Upload: <span class="req"><sup>*</sup>&nbsp;</span></label>'+
                            '<div class="md-btn md-btn-primary">'+
                                '<?php echo $this->form->input('upl_doc.', array('type'=>'file','label'=>false,'required'=>true)); ?>'+
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
