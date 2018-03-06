<?php $auth = $this->Session->read('Auth'); ?>

<?php echo $this->Form->create('Training', array('url' => array('controller' => 'training', 'action' => 'updateValidityDetail'), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return updatetype(this)', 'class' => 'uk-form-stacked')); ?>
<div class="uk-margin-medium-bottom">
    <label for="task_title">Course Validity Name<span class="req">*</span></label>
    <?php echo $this->Form->input('validity_name', array('type' => 'select', 'options' => $this->Common->getTrainingValidityList(), 'class' => 'md-input', 'label' => false, 'required' => 'required', 'id' => 'validity_name', 'value' => $ldetails['CourseValidityMaster']['validity_master_id'])); ?>
    <!--<input type="text" class="md-input" id="validity_name" name="validity_name" value="<?php echo $ldetails['CourseValidityMaster']['name']; ?>"/>-->
    <input type="hidden" class="md-input" name="validity_id" value="<?php echo $ldetails['CourseValidityMaster']['validity_id']; ?>"/>
</div>
<div class="uk-margin-medium-bottom">
    <label for="task_priority" class="uk-form-label">Company</label>
    <?php if (!empty($this->Common->chkValidityAsgnCourse($ldetails['CourseValidityMaster']['validity_id'], $ldetails['CourseValidityMaster']['org_id']))) { ?>
        <label for="task_priority" class="uk-form-label"><?php echo $this->Common->findCompanyNameByCode($ldetails['CourseValidityMaster']['org_id']); ?></label>
        <?php echo $this->Form->input('org_id', array('type' => 'select', 'options' => $company_lists, 'class' => 'md-input', 'style' => 'display: none', 'label' => false, 'required' => 'required', 'default' => $ldetails['CourseValidityMaster']['org_id'])); ?>
    <?php } else { ?>
        <?php echo $this->Form->input('org_id', array('type' => 'select', 'options' => $company_lists, 'class' => 'md-input', 'label' => false, 'required' => 'required', 'default' => $ldetails['CourseValidityMaster']['org_id'])); ?>
    <?php } ?>
</div>
<div class="uk-margin-medium-bottom">
    <label for="task_priority" class="uk-form-label">Status</label>
    <div>
        <span class="icheck-inline">
            <input type="radio" name="status" value="0" data-md-icheck <?php if ($ldetails['CourseValidityMaster']['status'] == 0) echo 'checked'; ?>/>
            <label for="task_priority_minor" class="inline-label uk-badge uk-badge-success">Enable</label>
        </span>
        <span class="icheck-inline">
            <input type="radio" name="status" value="1" data-md-icheck <?php if ($ldetails['CourseValidityMaster']['status'] == 1) echo 'checked'; ?>/>
            <label for="task_priority_critical" class="inline-label uk-badge uk-badge-warning">Disable</label>
        </span>
    </div>
</div>
<div class="uk-modal-footer uk-text-right">
    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button><button type="submit" class="md-btn md-btn-flat md-btn-flat-primary">Update</button>
</div>
<?php echo $this->Form->end(); ?>