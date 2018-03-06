<span class="uk-text-upper uk-text-small">
    <?php if($Action == '1'){?>
    <h3>Forward to HR !</h3>
    <?php }else{ ?>
        <h3>Reject with reason !</h3>
   <?php }?>
</span>

<?php echo $this->Form->create('adp_remark', array('url' => array('controller' => 'KraMasters', 'action' => 'adp_remark'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
<div class="md-card">
    <div class="md-card-content large-padding">
        <?php if($Action == '1'){?>
        <div class="uk-grid" id='TextBoxesGroup' data-uk-grid-margin>
            
            <div class="uk-width-medium-1-1" >
                <div class="parsley-row">
                    <label for="cc_num">Forward To*:</label>
                    
                        <?php 
                        echo $this->Form->input('forwardto', array('label'=>false,'type' => "select",'options'=>$HRlist,'empty'=>'--Select--','required'=>true,  'class' => "md-input data-md-selectize"));      
                        echo $this->Form->input('tni_id', array('type' => 'hidden','value'=>$vid_id, 'label' => false));
                        echo $this->Form->input('action', array('type' => 'hidden','value'=>$Action, 'label' => false));
                        ?>
                    
                </div>
            </div>                   
        </div>
        <?php }elseif($Action == '2'){
            ?>
        <div class="uk-grid" id='TextBoxesGroup' data-uk-grid-margin>
            
            <div class="uk-width-medium-1-1" >
                <div class="parsley-row">
                    <label for="cc_num">Reason*:</label>
                    
                        <?php 
                        echo $this->Form->input('mod_remarks', array('label'=>false,'type' => "text",'required'=>true,  'class' => "md-input data-md-selectize"));      
                        echo $this->Form->input('adp_id', array('type' => 'hidden','value'=>$adp_id, 'label' => false));
						echo $this->Form->input('user_id', array('type' => 'hidden','value'=>$user_id, 'label' => false));
                        echo $this->Form->input('action', array('type' => 'hidden','value'=>2, 'label' => false));
                        ?>
                    
                </div>
            </div>                   
        </div>
        <?php }?>
        <div class="uk-grid">
            <div class="uk-width-1-1">                        
                
                <button type="submit" name="submit" value="submit" class="md-btn md-btn-success" href="#">Reject</button>                    
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>
 