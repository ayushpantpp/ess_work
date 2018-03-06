
<div id="add_msg_div">
<div class="wfDtAppMapLvls form">
<?php echo $this->Form->create('WfDtAppMapLvl'); ?>
	<fieldset>
		<legend><?php echo __('Add Wf Dt App Map Lvl'); ?></legend>
	<?php   $company = $this->Common->findCompanyName();
                echo $this->Form->input('org_id',array('type'=>'select','options'=>$company,'empty'=>'Please select an Organization'));
		echo $this->Form->input('wf_app_map_lvl_id',array('type'=>'select','options'=>$applications,'empty'=>'Please select an application'));
		echo $this->Form->input('wf_lvl');
		echo $this->Form->input('wf_dept_id',array('type'=>'select','options'=>$departments,'empty'=>'Please select department'));
		echo $this->Form->input('wf_desg_id',array('type'=>'select','options'=>$designations,'empty'=>'Please select a designation'));
		echo $this->Form->input('created_date');
		echo $this->Form->input('skip_status');
		echo $this->Form->input('lvl_sequence');
		echo $this->Form->input('revoke_level_id',array('type'=>'select'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Wf Dt App Map Lvls'), array('action' => 'index')); ?></li>
	</ul>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#WfDtAppMapLvlWfAppMapLvlId").change(function(){
			app_change($(this).val());
		});

		app_change(2);
		

	});


	function app_change(app_id) {
			var list ='';
			$.ajax({
				url:'<?php echo $this->webroot; ?>wf_dt_app_map_lvls/app_wise_levels/'+app_id,
				success: function(data) {
					data = jQuery.parseJSON(data);
					$.each(data,function(index,value){
					 	list+="<option value='"+index+"'>"+value+"</option>";

					});
					$("#WfDtAppMapLvlRevokeLevelId").empty().append(list);

				}
			});
	}
</script>
