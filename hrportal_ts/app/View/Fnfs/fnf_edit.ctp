    <!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>FNF Edit Form</h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Fnf Form</h2>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"> <br />
                
                <?php
                echo $this->form->create('Fnf', array('url' => '','controller'=>'FnfController','action'=>'fnf_edit/'.$fnf_id,'inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));

                echo $this->Form->input('fnf_id',array('type'=>'hidden','value'=>$fnf_id, 'name'=>'Fnf[fnf_id]'));
                ?>

                <?php $auth=$this->Session->read('Auth');?>
                <div id="project_details">
                	<table class="table table-striped responsive-utilities jambo_table bulk_action">
                		<tr>
                			<th>Sr.No</th>
                			<th>Pending tasks</th>
                			<th>Approver Name</th>
                			<th>Task Completed</th>
                			<th>Completion date</th>
                		</tr>
                		<?php
                		$i=1;
                		//print_r($fnf_details);
                		foreach ($fnf_details as $value) {
                			$ctr = $value['FnfDetail']['id'];
                  		?>
                		<tr>
                			<td><?php echo $i;?></td>
                			<td><?php echo $value['Project']['name'];?></td>
                			<td><?php echo $value['MyProfile']['emp_firstname'].' '.$value['MyProfile']['emp_lastname'];?></td>
                			<td><?php 
                				
                				echo $this->Form->input('FnfDetail.completed',array('type'=>'checkbox','checked'=>false,'name'=> "FnfDetail[$ctr][completed]",'class' => 'testcheck','label'=>false, 'style'=>'opacity:1;'));



                			?>

                			</td>
                			<td><?php echo $this->Form->input('FnfDetail.completion_date',array('type'=>'textbox','name'=> "FnfDetail[$ctr][completion_date]",'class'=>'datepicker-textbox','label'=>false));?></td>
                		</tr>
                		<?php 
                		$i++;
                		} ?>
                	</table>
                </div>
                
                
                


                
                 
                  <div class="ln_solid"></div>
                  <div class="form-group col-md-1 col-sm-6 col-xs-12">
                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                      <input type="submit" class="btn btn-success" value="Submit To Manager" onclick="return CheckFnfCount(); ">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
 
      </div>
      <div id="repeatable-div" style="display:none">
      <div class="repeatable col-md-12" >
          <div class="form-group col-md-4 col-sm-6 col-xs-12">
            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Project Name<span class="required">*</span> </label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <?php 
              echo $this->Form->input('fnf_id',array('type'=>'hidden','value'=>$fnf_id, 'name'=>'Fnf[%ctr%][fnf_id]'));
              echo $this->Form->input('project_name',array(
                'type' => 'select',
                'options' => $project_list,
                'empty' => 'Please select a project',
                'label' => false,
                'name'  => 'Fnf[%ctr%][project_id]'
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
            <div class="col-md-8 col-sm-8 col-xs-12">
              <?php 
              echo $this->Form->input('user_name',array(
                'type' => 'select',
                'options' => $users_list,
                'empty' => 'Please select a user',
                'label' => false,
                'name'  => 'Fnf[%ctr%][approver_id]'
              ));
              ?>
            </div>
          </div>

        </div>
      </div>

	<script type="text/javascript">
	$(document).ready(function(){
		setTimeout(function(){
			$('.testcheck').css('opacity','1');

		},1000);

		jQuery(".datepicker-textbox").datepicker({
                inline: true,
                changeMonth: true,
                autoclose:true,
                //changeYear: true,
                dateFormat: 'dd-mm-yy',
                onSelect: function(selected) {
                    jQuery("#enddate").datepicker("option","minDate", selected);
                     var diff = dateDiff(jQuery('#startdate').datepicker("getDate"));
                     jQuery('#enddate').datepicker("getDate");
                     if(jQuery('#enddate').val() != ""){
                                var diff = dateDiff(jQuery('#startdate').datepicker("getDate"),
                                jQuery('#enddate').datepicker("getDate"));
                        }
                }
        });
		
		/*var g = $("#repeatable-div").html();
		var ct = $(".repeatable").length;
	  	g = g.replace(/\%ctr\%/g,ct);
	  	$('#project_details').append(g);

		$('#add_more').click(function(){
		  	var g = $("#repeatable-div").html();
			var ct = $(".repeatable").length;
		  	g = g.replace(/\%ctr\%/g,ct);
		  	$('#project_details').append(g);
		});*/

	});
	</script>


