<?php echo $this->Form->create('task', array('url' => array('controller' => 'tasks', 'action' => 'taskassign'), 'id' => 'form_validation', 'class' => 'uk-form-stacked', 'Onsubmit' => 'return passwordCompaire();')); ?>
<h3 class="heading_a">Please Fill to assign tasks.</h3>

<div class="uk-grid data-uk-grid-margin">
    <div class="uk-width-medium-1-2">
        <div class="parsley-row">
            <label for="ticket_id">Ticket ID: <span class="req">*</span></label>
            <input type="text" class="md-input" id="ticket_id" name="ticket_id" maxlength="25">                            

        </div>
    </div>
    <div class="uk-width-medium-1-2">
        <div class="parsley-row">
            <label for="ticket_type">Task Type: <span class="req">*</span></label>
            <input type="text" class="md-input" id="ticket_type" name="ticket_type" maxlength="25" required>                            
        </div>
    </div>
</div>
<div class="uk-grid data-uk-grid-margin">
    <div class="uk-width-medium-1-2">
        <div class="parsley-row">
            <label for="tid">Task ID: <span class="req">*</span></label>
            <input type="text" class="md-input" id="tid" name="tid" maxlength="25">                            

        </div>
    </div>
    <div class="uk-width-medium-1-2">
        <div class="parsley-row">
            <label for="tname">Task Name: <span class="req">*</span></label>
            <input type="text" class="md-input" id="tname" name="tname" maxlength="25" required>                            
        </div>
    </div>
</div>



<div class="uk-grid" data-uk-grid-margin>

    <div class="uk-width-medium-1-2">
        <label for="tpriority" class="uk-form-label">Task Priority</label>
        <select class="md-input" name="tpriority" id="tpriority" data-md-selectize-inline>
            <option value="0">Very High</option>
            <option value="1">High</option>
            <option value="2">Medium</option>
            <option value="3">Low</option>
        </select>
    </div>
    <div class="uk-width-medium-1-2">
        <div class="parsley-row">                                
            <?php echo $this->form->input('department_id', array('label' => "Department List", 'type' => "select", 'empty' => ' -- Select Department--', 'options' => $department_list, 'class' => "md-input", 'id' => 'department_list', 'required' => true, 'onChange' => 'return getEmployee(this.value)')); ?>
        </div>
    </div>
    <div class="uk-width-medium-1-2">
        <div class="parsley-row">
                            <label for="fullname">Project Name <span class="req">*</span></label>

                            <?php echo $this->form->input('pname', array('label'=>false, 'type' => 'select',
                        'options' => array('' => 'Select Project',$ar),
                        'value' => '','class' => "md-input",'required'=>true,'id'=>'pname', 'onChange'=>'getmodule(this.value)')); ?>

                        </div>
    </div>
</div>

<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-1-2">
        <div class="parsley-row">
            <label for="startdate">Start Date(d/m/y): <span class="req">*</span></label>
            <input type="text" class="md-input" id="uk_dp_1" data-uk-datepicker="{format:'DD.MM.YYYY'}" name="startdate" maxlength="25" value ="" required ="required">                            
        </div>
    </div>
    <div class="uk-width-medium-1-2">
        <div class="parsley-row" id = 'mname'>

        </div>
    </div>
</div>
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-1-2">
        <div class="parsley-row">
            <label for="enddate">End Date(d/m/y): <span class="req">*</span></label>
            <input type="text" class="md-input" data-uk-datepicker='{format:"DD-MM-YYYY"}' id="enddate" name="enddate" maxlength="25" value ="" required>                            
        </div>
        <div class="parsley-row">
            <label for="remark">Remark <span class="req">*</span></label>
            <?php echo $this->form->textarea('remark', array('label' => false, 'class' => "md-input", 'onkeyup' => "this.value=this.value.replace(/[^\w ]+$/g,'')")); ?>                
        </div>
        <div class="parsley-row" id = "empList">
            <span id="empList"></span>
        </div>
    </div>
</div>

<div class="uk-grid" data-uk-grid-margin>

</div>
<div class="uk-grid">
    <div class="uk-width-1-3 uk-margin-top">                            
        <button type="submit" name="submit" class="md-btn md-btn-success" href="#">Submit</button>                    
        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/users/dashboard') ?>">Cancel</a>                       
    </div>
</div>
<?php echo $this->Form->end(); ?>

</div>
</div>