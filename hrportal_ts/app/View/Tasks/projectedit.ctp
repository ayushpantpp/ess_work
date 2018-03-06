<?php echo $this->form->create('task', array('url'=>'','method'=>'post','action'=>'projectupdate',
    'inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'uk-form-stacked'))));?>

                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Project Name:<span class="required">*</span> </label>
                    
                      <?php echo $this->form->input('pname', array('class' => "md-input", 
                          'label'=>false,'value'=>$ar['Tasksproject']['pname'],'type' => 'text', 'id' =>'pname',
                          'onkeyup'=> "this.value=this.value.replace(/[^\w ]+$/g,'')",'required'=>true, 'autofocus'=>true)); ?>
                    
                    <?php echo $this->form->input('pid', array('class' => "md-input", 
                          'label'=>false,'value'=>$ar['Tasksproject']['pid'],'type' => 'hidden', 'id' =>'pid')); ?>
                    
                    <br>
                    <br>
                        <input type="submit" class="md-btn md-btn-success" value="Update" name='b1' id="b1"  />
                       
                               
                    

<?php echo $this->form->end(); ?>
<script type="text/javascript">
        $('.pname').bind('keyup blur',function(){ 
            var node = $(this);
            node.val(node.val().replace(/[^\w ]/$,'') ); }
        );
 </script> 