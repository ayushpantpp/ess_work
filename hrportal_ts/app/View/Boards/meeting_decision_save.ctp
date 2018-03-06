<script>
  function getMeetingRequst(val){ 
      
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Boards/meeting_decision_fields/' + val,
            //data:'project_id='+val,
            success: function (data) {
                $("#TextBoxesGroup").html(data);
                
            }
        });
        
    }
    
</script>
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            <h1>Enter Meeting Decision</h1>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card">  
            <div class="md-card-content large-padding">
                  <h3 class="heading_a">Meeting Decision</h3>
                <?php echo $this->Form->create('doc', array('url' =>array('controller' => 'Boards', 'action' =>'meeting_decision_save'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); 
                ?><br>
                  <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3" >
                            <div class="parsley-row">
                                <label for="req_cat">Meeting Number <span class="req">*</span></label>
                                <select name="meetNum" required="true" onchange="getMeetingRequst(this.value,'1')" class="md-input data-md-selectize">
                                    <?php
                                    $list = "<option value=' '>--Select--</option>";
                                    foreach($MeetNum as $key=>$rt){
                                        $list .= "<option value='".$key."'>".$rt."</option>";
                                        }
                                    echo $list;
                                    ?>
                                </select>
                                
                             </div>
                       </div>
                      <div class="uk-width-medium-1-3" ></div>
                      <div class="uk-width-medium-1-3" ></div>
				</div>
                      <div  id='TextBoxesGroup'>
                          
                          
                      </div>
					  
                   <div class="uk-grid" data-uk-grid-margin>
               <div class="uk-width-medium-1-2">
					<div class="parsley-row">
						<label for="subject"> Meeting Remark  </label>
						<?php echo $this->form->textarea('doc.meeting_remark.'.$keyval, array('type'=>'checkbox','label' => false, 'class' => "md-input")); 
						?>
						
					</div>
				</div>
				<div class="uk-width-medium-1-2">
				</div>
			</div>
		<br/>
                <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit"  class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('meeting_decision') ?>">Cancel</a>                       
                    </div>
                </div>
                </div>
        
                <?php echo $this->Form->end();?>
            </div>
           </div>
   </div>
</div>