<span class="uk-text-upper uk-text-small"><h3>Want To Send Any Other Files Manually !</h3></span>

<?php echo $this->Form->create('docs', array('url' => array('controller' => 'Documents', 'action' => 'request_complete'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
<div class="md-card">
    <div class="md-card-content large-padding">
        <div class="uk-grid" id='TextBoxesGroup' data-uk-grid-margin>
            <div class="uk-width-medium-1-1" >
                <div class="parsley-row">
                    <label for="cc_num">Manual Files: </label>
                    
                        <?php 
                        echo $this->form->input('upl_doc', array('type'=>'text','label'=>false,'class'=>"md-input")); 
                        echo $this->Form->input('reqID', array('type' => 'hidden','value'=>$reqID, 'label' => false));
                        echo $this->Form->input('docID', array('type' => 'hidden','value'=>$docID, 'label' => false));
                        ?>
                    
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
 