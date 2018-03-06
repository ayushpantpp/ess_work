
<div id="page_content" role="main">
    <div id="page_content_inner">        
        <h3 class="heading_b uk-margin-bottom">Add Meeting</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php echo $this->Form->create('mom', array('url' =>array('controller' => 'moms', 'action' =>'assign'),'id'=>'form_validation','enctype' => 'multipart/form-data','class' => 'uk-form-stacked')); ?>
                <?php echo $this->form->input('mid', array('class' => "md-input",'label' => false, 'value' => $meetingId, 'type' => 'hidden', 'id' => 'mid')); ?>
                    <div class="uk-grid" data-uk-grid-margin>
                        
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <?php $taskList = $this->Common->findTaskList();
                                echo $this->form->input('task_id', array('label' => "Task List", 'type' => "select",'empty' => ' -- Select Task --', 'options' => $taskList, 'class' => "md-input",'id' => 'task_id','data-md-selectize')); ?>                                
                            </div>
                        </div>
                        
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row"> 
                                <?php echo $this->form->input('subject', array('label' => "Subject *",'class' => "md-input",'type' => 'text', 'id' => 'date', 'required' => true,)); ?>                                
                            </div>
                        </div>                        
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row"> 
                                <?php echo $this->form->input('meeting_date', array('label' => "Meeting Date *", 'data-uk-datepicker' => "{format:'DD-MM-YYYY',minDate : 0}",'class' => "md-input",'type' => 'text', 'id' => 'date', 'required' => true,)); ?>                                
                            </div>
                        </div>
                        
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row"> 
                                <?php echo $this->form->input('meeting_time', array('label' => "Meeting Time *&nbsp;&nbsp;&nbsp;", 'class' => "uk-form-width-medium",'type' => 'number', 'id' => 'kUI_timepicker', 'required' => true)); ?>                                
                            </div>
                        </div>                        
                        
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">                                
                                <?php echo $this->form->input('res', array('label' => "Responsibility *", 'class' => "md-input", 'type' => "text", 'id' => 'responsibility','required' => true)); ?>                        
                            </div>
                        </div>                        
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <?php echo $this->form->input('meeting_remark', array('label' => "Minutes Remarks", 'type' => "text", 'class' => "md-input",'id' => 'mr')); ?>                                
                            </div>
                        </div>                       
                        
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <?php echo $this->form->input('remark', array('label' => "Remark", 'type' => "text", 'class' => "md-input",'id' => 'remark')); ?>                                
                            </div>
                        </div>
                        
                        <div class="uk-width-medium-1-2">                                                        
                            <div class="parsley-row">                                                            
                                <div class="uk-form-file md-btn md-btn-primary">
                                    Select
                                    <input id="doc_file" name="doc_file" type="file">
                                </div>
                                Upload Document <span class="req"></span>
                            </div>
                        </div>
                        
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">                                
                                <?php echo $this->form->input('des', array('class' => "md-input",'type' => "text", 'label' => "Description *", 'id' => 'des', 'required' => true)); ?>                                
                            </div>
                        </div>
                        
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">                                
                                <?php echo $this->form->input('department_id', array('label' => "Department List", 'type' => "select",'empty' => ' -- Select Department--', 'options' => $department_list, 'class' => "md-input",'id' => 'department_list', 'required' => true,'data-md-selectize','onChange' =>'return getEmployee(this.value)')); ?>
                            </div>
                        </div>                 
                    </div>
                    
                    <div class="uk-grid">
                        <div class="uk-width-medium-1-1">
                            <div class="parsley-row">                                
                                <span id="empList"></span>
                            </div>
                        </div> 
                    </div>
                
                                       
                    <div class="uk-grid">
                        <div class="uk-width-1-3 uk-margin-top">                            
                            <button type="submit" name="submit" class="md-btn md-btn-success" href="#">Submit</button>
                            <button type="reset" name="reset" class="md-btn md-btn-primary">Cancel</button>                            
                        </div>
                    </div>
                <?php echo $this->Form->end();?>
            </div>
        </div>        
    </div>
</div>
<script type="text/javascript">    

    function getEmployee(val) {
        //alert("--PROJECT ID--"+val);
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>moms/employeelist/' + val,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#empList").html(data);
            }
        });
    }
</script>   