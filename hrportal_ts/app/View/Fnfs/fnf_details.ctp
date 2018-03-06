<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            <h3>Employee Clearance Form</h3>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card">  
            <div class="md-card-content large-padding">
                 <?php $auth=$this->Session->read('Auth');?>
                 <?php
                echo $this->Form->create('Fnf', array('url' => '','controller'=>'FnfController','action'=>'fnf_details/'.$fnf_id,'inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));
                echo $this->Form->input('fnf_id',array('type'=>'hidden','value'=>$fnf_id, 'name'=>'Fnf[fnf_id]'));
                ?>
                <h3 class="heading_a">Pending task</h3>
                
                    <?php 
                    $ctr=1;
                    foreach ($project_list as $key => $value) {
                      /*print_r($key);
                      print_r($value);*/
                    ?>
                <div class="repeatable uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row fixed">
                            <label for="resp">
                                <?php 
                                echo $this->Form->input('fnf_id',array('type'=>'hidden','value'=>$fnf_id, 'name'=>"Fnf[$ctr][fnf_id]"));
                                echo $this->Form->input('fnf_id',array('type'=>'hidden','value'=>$key, 'name'=>"Fnf[$ctr][project_id]", 'class'=>'project_id'));
                                echo $value;
                                ?></label>
                            <?php
                            echo $this->form->textarea('Fnf[$ctr][remarks]', array('label'=>false,'class'=>"md-input"));
//                          echo $this->Form->input('remarks',array(
//                            'type' => 'textarea',
//                            'label' => false,
//                            'name' => "Fnf[$ctr][remarks]"
//                            ));
                          ?>               
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row ">
                            <label for="resp">Approver name<span class="req">*</span></label>
                            <?php //echo $this->form->input('task_id', array('label' => false, 'type' => "select", 'class' => "md-input ap_nm_".$ctr,'id' => 'approvername','data-md-selectize'));?>
                            <div id="approvername" class="ap_nm_<?php echo $ctr;?>"></div>           
                        </div>
                    </div>
                    
                    </div> 
                    <?php 
                     $ctr++;
                    } ?>
                    
                
                
                <div class="uk-grid" data-uk-grid-margin></div>
                
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit" class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('case_details/'.$caseID) ?>">Cancel</a>                       
                    </div>
                </div>
        
                <?php echo $this->Form->end();?>
            </div>
           </div>
   </div>
</div>

















<!-- page content -->
        

	<script type="text/javascript">
	$(document).ready(function(){
		
      $('.pr').each(function(){
        $(this).change(function(){
        var a = $(this).val(); 
        jQuery.ajax({
             url: '<?php echo $this->webroot ?>separations/approvername/'+a+'?user_id=<?php echo $fnf_details["Fnf"]["emp_code"];?>',

             success: function(data){

              console.log($(this).closest('.repeatable'));
              $('#approvername').html(data);

             }
         });
        });

      })

      $(".repeatable").each(function(){
        var a = $(this).find('.project_id').val(); 
        console.log(a);
        jQuery.ajax({
             url: '<?php echo $this->webroot ?>separations/approvername/'+a+'?user_id=<?php echo $fnf_details["Fnf"]["emp_code"];?>',

             success: function(data){

              data = data.replace(/\%ctr\%/g,a);
              $('.ap_nm_'+a).html(data);
             }
         });
      });

	});

    function task_changed(div_id) {
      var a = $(".pr_"+div_id).val(); 
      jQuery.ajax({
           url: '<?php echo $this->webroot ?>separations/approvername/'+a+'?user_id=<?php echo $fnf_details["Fnf"]["emp_code"];?>',

           success: function(data){

            console.log($(this).closest('.repeatable'));
            data = data.replace(/\%ctr\%/g,div_id);
            $('.ap_nm_'+div_id).html(data);

           }
       });
    }

</script>


