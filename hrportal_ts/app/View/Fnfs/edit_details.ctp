    <!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>FNFS Form</h3>
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
                echo $this->form->create('Fnf', array('url' => '','controller'=>'FnfController','action'=>'edit_details/'.$fnf_id,'inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));

                echo $this->Form->input('fnf_id',array('type'=>'hidden','value'=>$fnf_id, 'name'=>'Fnf[fnf_id]'));
                ?>

                <?php $auth=$this->Session->read('Auth');?>
                <a class="btn btn-primary pull-right" id="add_more">Add more pending tasks</a>
                <div id="project_details">
                    <?php 
                    $ctr = 1;
                    foreach ($fnf_details as $record) { ?>

        <div class="repeatable col-md-12" >
          <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Pending tasks<span class="required">*</span> </label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <?php 
              echo $this->Form->input('fnf_id',array('type'=>'hidden','value'=>$fnf_id, 'name'=>'Fnf[$ctr ][fnf_id]'));
              echo $this->Form->input('fnf_id',array('type'=>'hidden','value'=>$record['FnfDetail']['id'], 'name'=>'Fnf[$ctr ][id]'));
              echo $this->Form->input('project_name',array(
                'type' => 'select',
                'options' => $project_list,
                'empty' => 'Please select a task',
                'label' => false,
                'name'  => 'Fnf[$ctr][project_id]',
                'value' => $record['FnfDetail']['project_id']
              ));
              ?>
            </div>
          </div>
        
          <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Message">Remarks<span class="required">*</span> </label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <?php
              echo $this->Form->input('remarks',array(
                'type' => 'textarea',
                'label' => false,
                'name' => 'Fnf[$ctr][remarks]',
                'value' => $record['FnfDetail']['remarks']
                ));
              ?>
            </div>
          </div>
        </div>



                    <?php } ?>

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
          <div class="form-group col-md-6 col-sm-6 col-xs-12">
            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Pending task<span class="required">*</span> </label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <?php 
              echo $this->Form->input('fnf_id',array('type'=>'hidden','value'=>$fnf_id, 'name'=>'Fnf[%ctr%][fnf_id]'));
              echo $this->Form->input('project_name',array(
                'type' => 'select',
                'options' => $project_list,
                'empty' => 'Please select a pending task',
                'label' => false,
                'name'  => 'Fnf[%ctr%][project_id]'
              ));
              ?>
            </div>
          </div>
        
          <div class="form-group col-md-6 col-sm-6 col-xs-12">
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
        </div>
      </div>

	<script type="text/javascript">
	$(document).ready(function(){

		$('#add_more').click(function(){
		  	var g = $("#repeatable-div").html();
			var ct = $(".repeatable").length;
		  	g = g.replace(/\%ctr\%/g,ct);
		  	$('#project_details').append(g);
		});

	});
	</script>


