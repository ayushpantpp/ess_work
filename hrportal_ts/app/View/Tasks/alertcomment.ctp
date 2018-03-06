

<div id="page_content_inner">
            <div class="uk-overflow-container uk-margin-bottom">
                       <?php //echo "hi i am send alert page...===".$tid; ?>
                       <?php echo $this->form->create('task', array('url'=>'','method'=>'post','action'=>'alertcomment',
                        'inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));?>
                        <label for="remark">Add any Comment: <span class="req">*</span></label>
                        <?php echo $this->form->input('addcomment', array('class' => "md-input", 
                          'label'=>false,'type' => 'textarea', 'id' =>'addcomment', 'autofocus'=>true)); ?>
                        <?php echo $this->form->input('tid', array('class' => "form-control s-form-item s-form-all", 
                          'label'=>false,'value'=>$tid,'type' => 'hidden', 'id' =>'tid')); ?>
                        <br>
                    <br>
                    <input type="submit" class="md-btn md-btn-success" value="Send Alert" name='b1' id="b1" onclick="return chk()"  />
                        <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                
                          <!--<a href="sendalert/<?php //echo $data['TaskAssign']['tid']?>" class="btn btn-success btn-xs" title="Click to Send Alert.">Task Alert</a>-->     
                <?php echo $this->form->end(); ?>

            </div>
        </div>


