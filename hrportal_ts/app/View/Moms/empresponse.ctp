<?php //echo "hi i am send alert page...===".$tid; ?>
<?php echo $this->form->create('task', array('url'=>'','method'=>'post','action'=>'',
    'inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => ''))));?>

                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Employee Remarks Response:<span class="required"></span> </label>
                      <?php if($ar['MomAssign']['response']!=NULL){?>
                      <?php echo $this->form->input('mremark', array('class' => "form-control s-form-item s-form-all", 
                          'label'=>false,'type' => 'textarea', 'id' =>'mremark','readonly'=>true, 'value'=>$ar['MomAssign']['response'])); ?>
                      <?php } else { $st="--N/A--";?>
                        <?php echo $this->form->input('mremark', array('class' => "form-control s-form-item s-form-all", 
                          'label'=>false,'type' => 'textarea', 'id' =>'mremark','readonly'=>true, 'value'=>$st)); ?>
                      <?php } ?>
                    
<?php echo $this->form->end(); ?>

