<div class="wfDtAppMapLvls view">
<h2><?php echo __('Wf Dt App Map Lvl'); ?></h2>
	<dl>
		<dt><?php echo __('Wf Id'); ?></dt>
		<dd>
			<?php echo h($wfDtAppMapLvl['WfDtAppMapLvl']['wf_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Wf App Map Lvl Id'); ?></dt>
		<dd>
			<?php echo h($wfDtAppMapLvl['WfDtAppMapLvl']['wf_app_map_lvl_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Wf Lvl'); ?></dt>
		<dd>
			<?php echo h($wfDtAppMapLvl['WfDtAppMapLvl']['wf_lvl']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Wf Dept Id'); ?></dt>
		<dd>
			<?php echo h($wfDtAppMapLvl['WfDtAppMapLvl']['wf_dept_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Wf Desg Id'); ?></dt>
		<dd>
			<?php echo h($wfDtAppMapLvl['WfDtAppMapLvl']['wf_desg_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created Date'); ?></dt>
		<dd>
			<?php echo h($wfDtAppMapLvl['WfDtAppMapLvl']['created_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Skip Status'); ?></dt>
		<dd>
			<?php echo h($wfDtAppMapLvl['WfDtAppMapLvl']['skip_status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Revoke Level Id'); ?></dt>
		<dd>
			<?php echo h($wfDtAppMapLvl['WfDtAppMapLvl']['revoke_level_id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Wf Dt App Map Lvl'), array('action' => 'edit', $wfDtAppMapLvl['WfDtAppMapLvl']['wf_id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Wf Dt App Map Lvl'), array('action' => 'delete', $wfDtAppMapLvl['WfDtAppMapLvl']['wf_id']), array(), __('Are you sure you want to delete # %s?', $wfDtAppMapLvl['WfDtAppMapLvl']['wf_id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Wf Dt App Map Lvls'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Wf Dt App Map Lvl'), array('action' => 'add')); ?> </li>
	</ul>
</div>
