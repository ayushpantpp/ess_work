    <!-- page content -->
    
<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Employee Clearence Form </h3>


        <div class="md-card">
            <div class="md-card-content">
                
                <?php
                echo $this->Form->create('Fnf', array('url' => '','controller'=>'FnfController','action'=>'fnf_details/'.$fnf_id,'inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));

                echo $this->Form->input('fnf_id',array('type'=>'hidden','value'=>$fnf_id, 'name'=>'Fnf[fnf_id]'));
                ?>

                <?php $auth=$this->Session->read('Auth');?>
                <!-- <a class="btn btn-primary pull-right sperationaddtask" id="add_more">Add more tasks</a> -->
                <div id="project_details">
                  <?php 
                    $ctr=1;
                    foreach ($project_list as $key => $value) {
                      /*print_r($key);
                      print_r($value);*/
                    ?>
                    <div class="repeatable col-md-12" >
                      <div class="form-group col-md-4 col-sm-6 col-xs-12">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Pending task<span class="required">*</span> </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <?php 
                          echo $this->Form->input('fnf_id',array('type'=>'hidden','value'=>$fnf_id, 'name'=>"Fnf[$ctr][fnf_id]"));
                          echo $this->Form->input('fnf_id',array('type'=>'hidden','value'=>$key, 'name'=>"Fnf[$ctr][project_id]", 'class'=>'project_id'));
                          echo $value;
                          /*echo $this->Form->input('project_name',array(
                            'type' => 'select',
                            'options' => $project_list,
                            'empty' => 'Please select a task',
                            'label' => false,
                            'name'  => 'Fnf[%ctr%][project_id]',
                            'class' => 'form-control pr_%ctr%',
                            'onchange' => 'task_changed(%ctr%)'  
                          ));*/
                          ?>
                        </div>
                      </div>
                    
                      <div class="form-group col-md-4 col-sm-6 col-xs-12">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Message">Remarks </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <?php
                          echo $this->Form->input('remarks',array(
                            'type' => 'textarea',
                            'label' => false,
                            'name' => "Fnf[$ctr][remarks]"
                            ));
                          ?>
                        </div>
                      </div>

                      <div class="form-group col-md-4 col-sm-6 col-xs-12">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Approver name<span class="required">*</span> </label>
                        <div id="approvername" class="ap_nm_<?php echo $ctr;?>"></div>
                      </div>

                    </div>

                    <?php
                      $ctr++;
                  }?>
                </div>
                  <div class="ln_solid"></div>
                  <div class="form-group col-md-1 col-sm-6 col-xs-12">
                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                      <input type="submit" class="btn btn-success" value="Submit" id='submit' >
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
 
      </div>
      <!-- <div id="repeatable-div" style="display:none">
        <div class="repeatable col-md-12" >
          <div class="form-group col-md-4 col-sm-6 col-xs-12">
            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Pending task<span class="required">*</span> </label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <?php 
              echo $this->Form->input('fnf_id',array('type'=>'hidden','value'=>$fnf_id, 'name'=>'Fnf[%ctr%][fnf_id]'));
              echo $this->Form->input('project_name',array(
                'type' => 'select',
                'options' => $project_list,
                'empty' => 'Please select a task',
                'label' => false,
                'name'  => 'Fnf[%ctr%][project_id]',
                'class' => 'form-control pr_%ctr%',
                'onchange' => 'task_changed(%ctr%)'  
              ));
              ?>
            </div>
          </div>
        
          <div class="form-group col-md-4 col-sm-6 col-xs-12">
            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Message">Remarks<span class="required">*</span> </label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <?php
              echo $this->Form->input('remarks',array(
                'type' => 'textarea',
                'label' => false,
                'name' => 'Fnf[%ctr%][remarks]'
                ));
              ?>
            </div>
          </div>

          <div class="form-group col-md-4 col-sm-6 col-xs-12">
            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Approver name<span class="required">*</span> </label>
            <div id="approvername" class="ap_nm_%ctr%"></div>
          </div>

        </div>
      </div> -->

	<script type="text/javascript">
	$(document).ready(function(){
		/*var g = $("#repeatable-div").html();
		var ct = $(".repeatable").length;
	  	g = g.replace(/\%ctr\%/g,ct);*/
	  	//$('#project_details').append(g);

		$('#add_more').click(function(){
		  	var g = $("#repeatable-div").html();
			var ct = $(".repeatable").length;
		  	g = g.replace(/\%ctr\%/g,ct);
		  	$('#project_details').append(g);
		});
                
                /*$('#project_name').change(function(){
                var a = $('#project_name').val();   
               
                jQuery.ajax({
                     url: '<?php echo $this->webroot ?>separations/approvername/'+a+'?user_id=<?php echo $fnf_details["Fnf"]["emp_code"];?>',

                     success: function(data){

                      $('#approvername').html(data);

                     }
                 });
                });*/
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


