<?php //echo "hi i am send response page...===".$tid; ?>
<?php echo $this->form->create('mom', array('url'=>'','method'=>'post','action'=>'response',
    'inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));?>

                    <label class="control-label col-md-8 col-sm-8 col-xs-12">Please give your Remarks Response:<span class="required"></span> </label>
                    
                      <?php echo $this->form->input('mremark', array('class' => "form-control s-form-item s-form-all", 
                          'label'=>false,'type' => 'textarea', 'id' =>'mremark', 'required'=>TRUE)); ?>
                    
                    <?php echo $this->form->input('tid', array('class' => "form-control s-form-item s-form-all", 
                          'label'=>false,'value'=>$tid,'type' => 'hidden', 'id' =>'tid')); ?>
                    
                    <br>
                    <br>
                        <input type="submit" class="btn btn-success" value="Send" name='b1' id="b1"  />
                    
                    
<?php echo $this->form->end(); ?>

