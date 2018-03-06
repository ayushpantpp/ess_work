<?php// print_r($sr);  ?>
<?php echo $this->form->input('fid', array('label'=>false, 'type' => 'select', 
                        'options' => array('' => 'Select Function',$sr),
                        'value' => '','class' => "form-control col-md-7 col-xs-12",'id'=>'fid')); ?>