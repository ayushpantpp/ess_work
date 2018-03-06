<?php $auth = $this->Session->read('Auth'); ?>

<?php echo $this->Form->create('Training', array('url' => array('controller' => 'training', 'action' => 'updateTypeDetail'), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return updatetype(this)', 'class' => 'uk-form-stacked')); ?>
<div class="uk-margin-medium-bottom">
    <label for="task_title">Course Type Name</label>
    <input type="text" class="md-input" id="type_name" name="type_name" value="<?php echo $ldetails['CourseTypeMaster']['name']; ?>"/>
    <input type="hidden" class="md-input" name="type_id" value="<?php echo $ldetails['CourseTypeMaster']['type_id']; ?>"/>
</div>
<div class="uk-margin-medium-bottom">
    <?php echo $this->Form->input('org_id', array('type' => 'select', 'options' => $company_lists, 'class' => 'md-input', 'label' => 'Company', 'required' => 'required', 'default' => $ldetails['CourseTypeMaster']['org_id'])); ?>
</div>
<div class="uk-margin-medium-bottom">
    <label for="task_priority" class="uk-form-label">Status</label>
    <div>
        <span class="icheck-inline">
            <input type="radio" name="status" value="0" data-md-icheck <?php if ($ldetails['CourseTypeMaster']['status'] == 0) echo 'checked'; ?>/>
            <label for="task_priority_minor" class="inline-label uk-badge uk-badge-success">Enable</label>
        </span>
        <span class="icheck-inline">
            <input type="radio" name="status" value="1" data-md-icheck <?php if ($ldetails['CourseTypeMaster']['status'] == 1) echo 'checked'; ?>/>
            <label for="task_priority_critical" class="inline-label uk-badge uk-badge-warning">Disable</label>
        </span>
    </div>
</div>
<div class="uk-modal-footer uk-text-right">
    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button><button type="submit" class="md-btn md-btn-flat md-btn-flat-primary">Update</button>
</div>
<?php echo $this->Form->end(); ?>