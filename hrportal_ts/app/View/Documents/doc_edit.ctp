<div id="invoice_preview">
    <div class="md-card-toolbar">
        <h3 id="invoice_name" class="md-card-toolbar-heading-text large">
            Document Modification
        </h3>
    </div>
</div>       
<hr class="uk-grid-divider">
<div data-uk-grid-margin="" class="uk-grid">
    <div class="uk-width-medium-1-1 uk-row-first">
        <div class="md-card-content">        
            <?php //foreach($data as $alldata);?>
                <div class="md-card-content large-padding">
                <?php echo $flash = $this->Session->flash(); ?> 
                <?php echo $this->Form->create('docEdit', array('url' =>array('controller' => 'Documents', 'action' =>'doc_edit'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); ?>
                <h3 class="heading_a">Create New Mails & Files</h3>
                <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <?php 
                                echo $this->form->input('docid', array('label'=>false,'type' => "hidden",'value'=>$data['Category']['id'])); 
                                echo $this->form->input('parentID', array('label'=>false,'type' => "hidden",'value'=>$data['Category']['parent_id'])); 
                                echo $this->form->input('parent_ID', array('label'=>'Parent File','type' => "select",'disabled'=>'disabled','required'=>true,'empty' => ' -- Select Folder --', 'options' => $Folderlist, 'selected'=>$data['Category']['parent_id'], 'class' => "md-input",'data-md-selectize')); 
                                ?>
                             </div>
                       </div>
                    <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                
                                <?php 
                                echo $this->form->input('fname', array('label'=>'File Name*','type' => "text",'required'=>true,'value'=>$data['Category']['name'], 'class' => "md-input")); 
                                ?>
                             </div>
                       </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <div class="parsley-row">
                            <?php echo $this->form->input('remark', array('label'=>'Remark','type'=>'textarea','value'=>$data['Category']['remark'],'class'=>"md-input",'rows'=>'2','column'=>'2','onkeyup'=> "this.value=this.value.replace(/[^\w ]+$/g,'')",'onkeyblur'=> "this.value=this.value.replace(/[^\w ]+$/g,'')")); ?>                
                        </div>
                    </div>
                    
                </div> 
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit" class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    
                </div>
                
                <?php echo $this->Form->end();?>
            </div>
                                           
            
        </div>
    </div>
    
    
</div>




