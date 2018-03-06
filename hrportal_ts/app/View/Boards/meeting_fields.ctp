<?php if($reqID != ''){?>
<div class="uk-width-medium-1-4">
    <div class="parsley-row">
        <label for="subject">Serial # <span class="req">*</span></label>
        <?php echo $this->form->input('req_ref_serial_no', array('type'=>'text','label' => false,'disabled'=>'disabled','value'=>$reqRef['0']['BMReceiveRequest']['req_ref_serial_no'], 'required' => true, 'class' => "md-input")); ?>                
    </div>
</div>

<div class="uk-width-medium-1-4">
    <div class="parsley-row">
        <label for="subject">Subject <span class="req">*</span></label>
        <?php echo $this->form->input('acad', array('type'=>'text','label' => false,'disabled'=>'disabled','value'=>$reqRef['0']['BMReceiveRequest']['subject'], 'required' => true, 'class' => "md-input")); ?>                
    </div>
</div>

<div class="uk-width-medium-1-4">
    <div class="parsley-row">
        <label for="subject">Department <span class="req">*</span></label>
        <?php echo $this->form->input('prof', array('type'=>'text','label' => false, 'disabled'=>'disabled','value'=>$this->common->findDepNamebycode($reqRef['0']['BMReceiveRequest']['dept_code']),'required' => true, 'class' => "md-input")); ?>                
    </div>
</div>

<div class="uk-width-medium-1-4">
    <div class="parsley-row">
        <label for="subject">Date of Request <span class="req">*</span></label>
        <?php echo $this->form->input('exp', array('type'=>'text','label' => false,'disabled'=>'disabled','value'=>date("d/m/Y", strtotime($reqRef['0']['BMReceiveRequest']['date_of_request'])) ,'required' => true, 'class' => "md-input")); ?>                
    </div>
</div>
<?php }?>
