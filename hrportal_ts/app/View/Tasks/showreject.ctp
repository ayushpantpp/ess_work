
<?php //echo "<h2>-hiii in page-".$tid; ?>   
<?php echo $this->form->create('task', array('url'=>'','method'=>'post','action'=>'showreject',
    'inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));?>
                 
<label class="control-label col-md-4 col-sm-4 col-xs-12"><h4>Reason for reject a task:<span class="required">*</span></h4> </label>
                    
                      <?php echo $this->form->input('cm', array('class' => "form-control s-form-item s-form-all", 
                          'label'=>false,'type' => 'textarea', 'id' =>'cm', 'value'=>$ar2['TaskAssign']['comment'], 'readonly'=>true)); ?>
                    
                    <?php echo $this->form->input('tid', array('class' => "form-control s-form-item s-form-all", 
                          'label'=>false,'value'=>$tid,'type' => 'hidden', 'id' =>'tid')); ?>
                    
                    <br>
                    <br>
                        <!--<input type="submit" class="btn btn-success" value="Close" name='b1' id="b1"  />-->
                       
                               
                    

<?php echo $this->form->end(); ?>