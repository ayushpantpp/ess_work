<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            <h1>Enter Case Details</h1>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <?php
//        echo "<pre>";
//        print_r($ReportAttachDet);
//        ?>
       <div class="md-card">  
            <div class="md-card-content large-padding">
               
                <?php echo $this->Form->create('doc', array('url' =>array('controller' => 'Boards', 'action' =>'report_type_attach_update'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); 
                echo $this->form->input('reportid', array('type' => "hidden",'value'=>$ReportAttachDet['BMReportTypeAttachment']['id'])); 
                ?>
                <h3 class="heading_a">Attachment Details</h3>
                <div class="uk-grid" data-uk-grid-margin>
                    
                    <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="case_type" class="md-input label-fixed">Data Type <span class="req">*</span></label>
                                    <?php
                                    echo $this->form->input('data_type', array('label'=>false,'type' => "select",'default'=>$ReportAttachDet['BMReportTypeAttachment']['data_type_id'],'empty'=>'-- Select --','required'=>true,'options' => $DataTypeList,'class' => "md-input",'data-md-selectize')); 
                                    ?>
                             </div>
                       </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="remark">Remark </label>
                            <?php echo $this->form->textarea('remark', array('label'=>false,'value'=>$ReportAttachDet['BMReportTypeAttachment']['remark'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    
                </div> 
            <div class="uk-grid"  data-uk-grid-margin>
            
                
                
                <?php 
                foreach($ReportAttachDet['BMReportTypeAttachFiles'] as $recc){?>
                    <div class="uk-width-medium-1-2" >
                    <?php
                  echo $recc['attach_file'];?>
                </div>
                <div class="uk-width-medium-1-2" >
                <a class="md-btn md-btn-danger" href="<?php echo $this->Html->url('report_attach_file_remove/'.$ReportAttachDet['BMReportTypeAttachment']['id'].'/'.$recc['id']); ?>">Remove</a>                       
                </div>
                      <?php
                }
                ?>
                
            </div> 
            <div class="uk-grid" id='TextBoxesGroup' data-uk-grid-margin>
            <div class="uk-width-medium-1-2" >
                <div class="uk-form-file md-btn md-btn-primary">
                    <label for="cc_num"  >Select File To Upload: </label>
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
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('report_type_attach'); ?>">Cancel</a>                       
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
         .attr({id:'TextBoxDiv' + counter,class:"uk-width-medium-1-2 margin-bottom"});
 
    newTextBoxDiv.after().html('<br><div class="parsley-row uk-form-file md-btn md-btn-primary">'+
                            '<label for="upl_doc">Select File To Upload: <span class="req"><sup>*</sup>&nbsp;</span></label>'+
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
