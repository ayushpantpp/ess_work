<script>
    function fieldsDisable(val){
        if(val!=''){
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
            
            <h1>Request Receive</h1>
            
        </div>
    
    
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card">  
            <div class="md-card-content large-padding">
                 <?php 
                 
                 if(!empty($reqData)){
                     foreach($reqData as $rec);
                     
                 }?>
                <?php echo $this->Form->create('doc', array('url' =>array('controller' => 'Boards', 'action' =>'req_receive_edit'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); 
                echo $this->form->input('reqID', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$rec['BMReceiveRequest']['id'],'class'=>"md-input"));
                
                ?>
                <h3 class="heading_a">Request Receiving</h3>
                <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="req_cat">Request Category <span class="req">*</span></label>
                                <select name="req_cat" required="required" class="md-input data-md-selectize label-fixed">
                                    <option value=" ">-- Select --</option>
                                    <?php 
                                    foreach($RequestType as $key=>$rt){
                                    $value = $key;
                                    $option = $rt;
                                    if($value == $rec['BMReceiveRequest']['request_type_id']){
                                        echo "<option value='".$value."' selected='selected'>".$option."</option>";
                                    }else{
                                        echo "<option value='".$value."'>".$option."</option>";
                                    }
                                        
                                    }
                                    ?>
                                </select>
                                  
                             </div>
                       </div>
                       <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="department">Department <span class="req">*</span></label>
                                <select name="department" required="required" onchange="fieldsDisable(this.value);" class="md-input data-md-selectize label-fixed">
                                    <option value=" ">-- Select --</option>
                                    <?php
                                    foreach($department as $key => $rt){
                                    $value = $key;
                                    $option = $rt;
                                    if($rec['BMReceiveRequest']['dept_code']==$value){
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
                    
                
                      <div class="uk-grid" data-uk-grid-margin > 
                          
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Reference Number <span class="req fixed">*</span></label>
                            <?php echo $this->form->input('refnum', array('type'=>'text','label'=>false,'required'=>true,'value'=>$rec['BMReceiveRequest']['reference_num'],'class'=>"md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="subject">Subject <span class="req">*</span></label>
                            <?php echo $this->form->textarea('subject', array('label'=>false,'required'=>true,'value'=>$rec['BMReceiveRequest']['subject'],'class'=>"md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="dor">Date of Request <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('doreq', array('type' => "text",'label'=>false,'required'=>true,'data-uk-datepicker'=>'{format:"DD-MM-YYYY"}','value'=>date("d-m-Y", strtotime($rec['BMReceiveRequest']['date_of_request'])), 'class' => "md-input")); 
                                ?>
                                <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="dorc">Date of Received <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('dorec', array('type' => "text",'label'=>false,'required'=>true,'data-uk-datepicker'=>'{format:"DD-MM-YYYY"}','value'=>date("d-m-Y", strtotime($rec['BMReceiveRequest']['date_of_receive'])), 'class' => "md-input")); 
                                ?>
                                <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="act_off">Signatory<span class="req">*</span></label>
                                <select name="signatory" required="required" class="md-input data-md-selectize label-fixed">
                                    <option value=" ">-- Select --</option>
                                    <?php
                                    foreach($Dept_Signatory as $key=>$values){
                                 $value = $key;
                                 $option = $values;
                                 if($value == $rec['BMReceiveRequest']['signatory_id']){
                                     echo "<option value='".$value."' selected='selected'>".$option."</option>";
                                 }else{
                                        echo "<option value='".$value."'>".$option."</option>";
                                 }
                                }
                                
                                    ?>
                                </select>
                        </div>
                    
                    </div>
                          
                          <div id="newfield" class="uk-width-medium-1-2">
                              <div class="parsley-row">
                                <label for="act_off">Marking Officer <span class="req">*</span></label>
                                
                                <select name="act_off" required="required" class="md-input data-md-selectize label-fixed">
                                    <option value=" ">-- Select --</option>
                                    <?php
                                   foreach($ActionOfficer as $key=>$values){
                                    $value = $key;
                                    $option = $values;
                                    if($value == $rec['BMReceiveRequest']['action_officer_id']){
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
                <?php echo $this->Form->end();?>
            </div>
           </div>
   </div>
</div>
