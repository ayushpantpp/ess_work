<?php echo $this->form->create('task', array('url'=>'','method'=>'post','action'=>'functionupdate',
    'inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'uk-form-stacked'))));?>
                    
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Function Name:<span class="required">*</span> </label>
                    
                      <?php echo $this->form->input('mname', array('class' => "md-input", 
                          'label'=>false,'value'=>$sr['Tasksprojectmodule']['mname'],'type' => 'text', 'id' =>'mname',
                          'onkeyup'=> "this.value=this.value.replace(/[^\w ]+$/g,'')",'required'=>true, 'autofocus'=>true)); ?>
                    
                    <?php echo $this->form->input('pid', array('class' => "md-input", 
                          'label'=>false,'value'=>$sr['Tasksprojectmodule']['mid'],'type' => 'hidden', 'id' =>'pid')); ?>
                    
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