<div class="uk-width-medium-1-3">
    <div class="parsley-row">
        <label for="subject">Academic <span class="req">*</span></label>
        <?php echo $this->form->textarea('acad', array('label' => false, 'required' => true, 'class' => "md-input")); ?>                
    </div>
</div>

<div class="uk-width-medium-1-3">
    <div class="parsley-row">
        <label for="subject">Professional <span class="req">*</span></label>
        <?php echo $this->form->textarea('prof', array('label' => false, 'required' => true, 'class' => "md-input")); ?>                
    </div>
</div>

<div class="uk-width-medium-1-3">
    <div class="parsley-row">
        <label for="subject">Experience <span class="req">*</span></label>
        <?php echo $this->form->textarea('exp', array('label' => false, 'required' => true, 'class' => "md-input")); ?>                
    </div>
</div>
