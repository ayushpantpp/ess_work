<h4><?php echo $ar['TaskAlert']['comment']; ?></h4>

<?php echo $this->form->create('task', array('url'=>'','method'=>'post','action'=>'getalert',
    'inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));?>

                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Employee Comment:<span class="required">*</span> </label>
                    
                      <?php echo $this->form->input('emp', array('class' => "form-control s-form-item s-form-all", 
                          'label'=>false,'type' => 'textarea', 'id' =>'emp', 'value'=> $ar['TaskAlert']['emp_reply'], 'readonly'=>true)); ?>
                    
                    <?php echo $this->form->input('tid', array('class' => "form-control s-form-item s-form-all", 
                          'label'=>false,'value'=>$tid,'type' => 'hidden', 'id' =>'tid')); ?>
                    
                    <br>
                    <br>
                        <input type="submit" class="btn btn-success" value="Close Alert" name='b1' id="b1"  />
                       
                               
                    

<?php echo $this->form->end(); ?>