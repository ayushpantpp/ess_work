<script>
    function fields_Disable(val){
        if(val!=''){
        //var val=jQuery("#type").val();
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Boards/frwrd_fields/' + val,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#new_field").html(data);
                $("#hrzntl_up").show();
                $("#hrzntl_dn").show();
                
            }
        });
        }
    }
    
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
            
            <h1>Request Forward</h1>
            
        </div>
    
    
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card">  
            <div class="md-card-content large-padding">
                 <?php 
                 if(!empty($EditCaseReceive)){
                     foreach($EditCaseReceive as $rec);
                 } ?>
                <?php 
                echo $this->Form->create('doc', array('url' =>array('controller' => 'Boards', 'action' =>'req_forward_save'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); 
                ?>
                <h3 class="heading_a">Request Forwarding</h3>
                <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="req_cat">Request Reference Number <span class="req">*</span></label>
                                <select name="req_id" required="required" onchange="fields_Disable(this.value);" class="md-input data-md-selectize label-fixed">
                                   
                                    
                                    <option value=" ">-- Select --</option>
                                    <?php 
                                 
                                foreach($RefNum as $list){
                                //$listing[$list['BMReceiveRequest']['id']] = $list['BMReceiveRequest']['reference_num'];
                                
                                    
                                        echo "<option value='".$list['BMReceiveRequest']['id']."'>".$list['BMReceiveRequest']['reference_num']."</option>";
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
                    
                    <div  class="uk-grid" data-uk-grid-margin></div>
                    
					
					<div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Remark <span class="req fixed">*</span></label>
                            <?php
                            echo $this->form->input('remark', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
                           
                            ?>                
                        </div>
                    </div>
					<div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                           <div id="newfield"></div>
                           
                                
                        </div>
                    </div>
					
                    
                    <div  class="uk-grid" data-uk-grid-margin></div>
                    </div>
                <hr class="uk-grid-divider" id="hrzntl_up" style="display: none">
                
                    <div id="new_field"  class="uk-grid" data-uk-grid-margin>
                        
                    
                    </div>
                <div  class="uk-grid" data-uk-grid-margin></div>
                <hr class="uk-grid-divider" id="hrzntl_dn" style="display: none">
                     
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit" class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/Boards/req_forward') ?>">Cancel</a>                       
                    </div>
                </div>
                <?php echo $this->Form->end();?>
            </div>
           </div>
   </div>
</div>
