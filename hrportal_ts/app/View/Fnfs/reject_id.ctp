<script>
function checkSubmit()
    {   
            var rem = jQuery('#remark').val();
            if(rem == ''){
                alert('Please Enter Remark');
                return false;
            }
    }
</script>   







<div id="invoice_preview">
    <div class="md-card-toolbar">
        <h3 id="invoice_name" class="md-card-toolbar-heading-text large">
            Reason
        </h3>
    </div>
</div>       
<hr class="uk-grid-divider">
<div data-uk-grid-margin="" class="uk-grid">
    <div class="uk-width-medium-1-1 uk-row-first">
        <div class="md-card-content">        
            <div data-uk-grid-margin="" class="uk-grid"><?php //foreach($data as $alldata);?>
                <div class="md-card-content large-padding">
                <?php
echo $this->Form->create('Fnf', array('inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => array(
                        'wrap' => 'span',
                        'class' => 'my-error-class'
                )
        ), 'url' => array('controller' => 'Fnfs', 'action' => 'reject_fnf'), 'id' => 'att', 'name' => 'Fnfs','enctype'=>'multipart/form-data'));
?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1" >
                            <div class="parsley-row">
                                <label for="cc_num"  >Reject Reason: </label>
                                <?php 
                                //echo $this->form->input('fname', array('label'=>'Folder Name','type' => "text",'required'=>true,'value'=>$data['Category']['name'], 'class' => "md-input")); 
                                ?>
                                <?php echo $this->Form->input('Fnfs.remark', array('label' => false, 'type' => 'text','required'=>true,'class' => 'md-input')); ?>
                        <?php echo $this->Form->input('Fnfs.rejectid', array('label' => false, 'type' => 'hidden','class' => 'md-input','value'=>$rejectid)); ?>
                             </div>
                       </div>
                </div> 
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top"> 
                        <button type="submit" name="submit" value="Reject" class="md-btn md-btn-success" onclick ="return checkSubmit();" href="#">Reject</button>                    
                    </div>
                    
                </div>
                
                <?php echo $this->Form->end();?>
            </div>
                                           
            </div>
        </div>
    </div>
    
    
</div>
























