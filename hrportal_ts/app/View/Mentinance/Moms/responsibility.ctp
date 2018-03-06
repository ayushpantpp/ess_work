<?php //echo "hi i am send alert page...===".$tid; echo "<pre>".$ar['MomAssign']['responsibility']."<br>";print_r($ar);?>


<label class="control-label col-md-4 col-sm-4 col-xs-12">MOM Responsibility:<span class="required"></span> </label><br><br>
                      <?php if($ar['MomAssign']['responsibility']!=NULL){?>
                      <?php echo $this->form->input('mremark', array('class' => "form-control s-form-item s-form-all", 
                          'label'=>false,'type' => 'textarea', 'id' =>'mremark','readonly'=>true, 'value'=>$ar['MomAssign']['responsibility'])); ?>
                      <?php } else { $st="--N/A--";?>
                        <?php echo $this->form->input('mremark', array('class' => "form-control s-form-item s-form-all", 
                          'label'=>false,'type' => 'textarea', 'id' =>'mremark','readonly'=>true, 'value'=>$st)); ?>
                      <?php } ?>
                    


