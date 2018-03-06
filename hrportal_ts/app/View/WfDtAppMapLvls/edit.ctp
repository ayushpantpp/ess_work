<div class="wfDtAppMapLvls form">
<?php echo $this->Form->create('WfDtAppMapLvl'); ?>
	<fieldset>
		<legend><?php echo __('Edit Wf Dt App Map Lvl'); ?></legend>
	<?php
		echo $this->Form->input('wf_id');
		echo $this->Form->input('wf_app_map_lvl_id',array('type'=>'hidden'));
		echo $this->Form->input('wf_lvl');
		echo $this->Form->input('wf_dept_id',array('type'=>'select','options'=>$departments,'empty'=>'Please select department'));
		echo $this->Form->input('wf_desg_id',array('type'=>'select','options'=>$designations,'empty'=>'Please select a designation'));
		echo $this->Form->input('created_date');
		echo $this->Form->input('skip_status');
		echo $this->Form->input('lvl_sequence');
		echo $this->Form->input('revoke_level_id',array('type'=>'select','options'=>$levels));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('WfDtAppMapLvl.wf_id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('WfDtAppMapLvl.wf_id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Wf Dt App Map Lvls'), array('action' => 'index')); ?></li>
	</ul>
</div>


