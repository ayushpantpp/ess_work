<?php //echo "hi i am send alert page...===".$tid; ?>
<?php echo $this->form->create('task', array('url'=>'','method'=>'post','action'=>'',
    'inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));?>

                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Details of Minutes Remarks:<span class="required"></span> </label>
                    
                      <?php echo $this->form->input('mremark', array('class' => "form-control s-form-item s-form-all", 
                          'label'=>false,'type' => 'textarea', 'id' =>'mremark','readonly'=>true, 'value'=>$ar['MomAssign']['mremark'])); ?>
                    
                    
<?php echo $this->form->end(); ?>

