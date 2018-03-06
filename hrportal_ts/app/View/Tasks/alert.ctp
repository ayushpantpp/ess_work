<div id="invoice_preview">
    <div class="md-card-toolbar">
        <h3 id="invoice_name" class="md-card-toolbar-heading-text large">
            Alert and Remarks
        </h3>
    </div>
</div>       
<hr class="uk-grid-divider">
<div data-uk-grid-margin="" class="uk-grid">
    <div class="uk-width-medium-1-2 uk-row-first">
        <div class="md-card-content">        
            <div data-uk-grid-margin="" class="uk-grid">
                <div class="uk-grid">
                        <div class="uk-width-1-1">
                            <div class="parsley-row">                                
                              </div>
                        </div>
                    </div>
                    <div class="uk-grid">
                        <div class="uk-width-1-1">
                         <p><?php echo "<h4>".$ar2['TaskAlert']['comment']."</h4>"; ?> </p>
                        <?php echo $this->form->create('task', array('url'=>'','method'=>'post','action'=>'alert',
                            'inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));?>
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Comment:<span class="required">*</span> </label>
                            <?php echo $this->form->input('cm', array('class' => "form-control s-form-item s-form-all", 
                            'label'=>false,'type' => 'textarea', 'id' =>'cm', 'required'=>true, 'autofocus'=>true)); ?>
                    <?php echo $this->form->input('tid', array('class' => "form-control s-form-item s-form-all", 
                    'label'=>false,'value'=>$tid,'type' => 'hidden', 'id' =>'tid')); ?>
                    <br>
                    <br>
                        <input type="submit" class="md-btn md-btn-success" value="Reply" name='b1' id="b1"  />
                     
<?php echo $this->form->end(); ?>
                        </div>
                    </div>
                               
            </div>
        </div>
    </div>
    
    <div class="uk-width-medium-1-2">
        <h2 class="uk-text-success heading_a">Previous Alerts List: </h2>
            <div class="uk-overflow-container">
            <ul class="md-list md-list-addon md-list-left">
                <li>
                    <div class="md-list-addon-element">
                       
                    </div>
                    <div class="md-list-content">
                        <span class="md-list-heading"> <?php echo ucfirst($ar2[0]['TaskAlert']['comment']);?></span>
                        <span class="uk-text-small uk-text-muted"><?php echo $this->Common->getempname($ar2[0]['TaskAlert']['emp_code']); ?></span>
                        <span class="uk-text-small uk-text-muted"><?php echo $this->Common->findDesignationName($ar2[0]['TaskAlert']['desg_code'], $comp_code); ?></span>
                    </div>
                </li>       
            </ul>
        </div>
    </div>
</div>







