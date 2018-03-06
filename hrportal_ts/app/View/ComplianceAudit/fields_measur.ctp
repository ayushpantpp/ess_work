<div class="parsley-row">
    <label for="department">Measurement <span class="req">*</span></label>
    <?php
    echo $this->form->input('measurement', array('label' => false, 'id' => 'measurement', 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'disabled'=>'disabled','options' => $measurType,'default'=>$default, 'class' => "md-input", 'data-md-selectize'));
    echo $this->form->input('measurement_type', array('label' => false, 'id' => 'measurement','value'=>$default, 'type' => "hidden",  'required' => true));
    ?>
</div>
