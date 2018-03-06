<?php

$auth=$this->Session->read('Auth');?>
<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Select Financial Year</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php echo $this->Form->create('fy', array('inputDefaults' => array(
               'label' => false,'div' => false, 'error' => array( 'wrap' => 'span','class' => 'uk-form-stacked my-error-class' )),
               'url' => array('controller' => 'income_tax', 'action' => 'hrView'), 'id' => 'ltaid', 'name' => 'fy'));
                ?>

                <div class="md-card-content" data-uk-grid-margin>
                    <div class="uk-overflow-container" role="main">
                        <div class="uk-grid">
                            <div class="uk-width-medium-1-2">
                                <label>Select Year <span class="required">*</span> </label>
                                <div class="parsley-row">
                                    <input type="hidden" value ="<?php echo $id; ?>" name="lta_id"> 
                      <?php echo $this->Form->input('fy_year', array('type' => 'select', 'label' => false, 'options' => $financialYear, 'class' => 'md-input form-control s-form-item s-form-all','id'=>'fwlvempcode')); ?>
                                </div>
                            </div>
                            <div class="uk-width-1-1 uk-margin-top">
                                <?php echo $this->Form->submit('Submit', array('name'=>'data[fy][save]','class'=>'md-btn md-btn-success btn btn-success')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                  <?php $this->Form->end(); ?>

            </div>
        </div>
    </div>
</div>
